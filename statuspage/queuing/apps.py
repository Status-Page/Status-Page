import logging
import sys

import django_rq
from django.apps import AppConfig
from django.db.models import Q
from django.utils import timezone


class QueuingConfig(AppConfig):
    default_auto_field = 'django.db.models.BigAutoField'
    name = 'queuing'

    def ready(self):
        scheduler = django_rq.get_scheduler('default')
        if sys.argv[1:2] == ["collectstatic"]:
            return None
        jobs = list(map(lambda j: j.func_name, scheduler.get_jobs()))

        tasks = [
            (maintenance_automation, '* * * * *'),
            (subscriber_automation, '* * * * *'),
            (metric_automation, '0 0 * * *'),
            (housekeeping, '0 4 * * *'),
        ]

        for task, cron_string in tasks:
            func_name = get_func_name(task)
            if func_name not in jobs:
                scheduler.cron(
                    cron_string=cron_string,
                    func=task,
                    queue_name='default',
                )


def get_func_name(func):
    return '{0}.{1}'.format(func.__module__, func.__qualname__)


def maintenance_automation():
    from maintenances.models import Maintenance, MaintenanceUpdate
    from maintenances.choices import MaintenanceStatusChoices
    from components.choices import ComponentStatusChoices

    started_maintenances = Maintenance.objects.filter(
        status=MaintenanceStatusChoices.SCHEDULED,
        scheduled_at__lte=timezone.now(),
        start_automatically=True,
    )
    for maintenance in started_maintenances:
        update = MaintenanceUpdate()
        update.maintenance = maintenance
        update.text = 'This Maintenance has been started.'
        update.new_status = True
        update.status = MaintenanceStatusChoices.IN_PROGRESS
        update.save()
        maintenance.components.update(status=ComponentStatusChoices.MAINTENANCE)
        maintenance.status = MaintenanceStatusChoices.IN_PROGRESS
        maintenance.save()

    completed_maintenances = Maintenance.objects.filter(
        ~Q(status=MaintenanceStatusChoices.COMPLETED),
        end_at__lte=timezone.now(),
        end_automatically=True,
    )
    for maintenance in completed_maintenances:
        update = MaintenanceUpdate()
        update.maintenance = maintenance
        update.text = 'This Maintenance has been completed.'
        update.new_status = True
        update.status = MaintenanceStatusChoices.COMPLETED
        update.save()
        maintenance.components.update(status=ComponentStatusChoices.OPERATIONAL)
        maintenance.status = MaintenanceStatusChoices.COMPLETED
        maintenance.save()


def metric_automation():
    from metrics.models import MetricPoint

    datenow = timezone.now().replace(microsecond=0, second=0, minute=0, hour=0)
    daterange = datenow - timezone.timedelta(days=31)

    MetricPoint.objects.filter(created__lte=daterange).delete()


def subscriber_automation():
    from subscribers.models import Subscriber

    daterange = timezone.now() - timezone.timedelta(days=1)
    Subscriber.objects.filter(created__lte=daterange, email_verified_at=None).delete()


def housekeeping():
    from datetime import timedelta
    from importlib import import_module

    from django.conf import settings
    from django.db import DEFAULT_DB_ALIAS
    from django.utils import timezone

    from extras.models import ObjectChange
    from statuspage.config import Config

    config = Config()

    logger = logging.Logger('statuspage.housekeeping')

    # Clear expired authentication sessions (essentially replicating the `clearsessions` command)
    logger.info('[*] Clearing expired authentication sessions')
    logger.debug(f"\tConfigured session engine: {settings.SESSION_ENGINE}")
    engine = import_module(settings.SESSION_ENGINE)
    try:
        engine.SessionStore.clear_expired()
        logger.info("\tSessions cleared.")
    except NotImplementedError:
        logger.error(
            f"\tThe configured session engine ({settings.SESSION_ENGINE}) does not support "
            f"clearing sessions; skipping."
        )

    # Delete expired ObjectRecords
    logger.info("[*] Checking for expired changelog records")
    if config.CHANGELOG_RETENTION:
        cutoff = timezone.now() - timedelta(days=config.CHANGELOG_RETENTION)
        logger.debug(f"\tRetention period: {config.CHANGELOG_RETENTION} days")
        logger.debug(f"\tCut-off time: {cutoff}")
        expired_records = ObjectChange.objects.filter(time__lt=cutoff).count()
        if expired_records:
            logger.info(
                f"\tDeleting {expired_records} expired records... ",
            )
            ObjectChange.objects.filter(time__lt=cutoff)._raw_delete(using=DEFAULT_DB_ALIAS)
            logger.info("Done.")
        else:
            logger.info("\tNo expired records found.")
    else:
        logger.info(
            f"\tSkipping: No retention period specified (CHANGELOG_RETENTION = {config.CHANGELOG_RETENTION})"
        )
