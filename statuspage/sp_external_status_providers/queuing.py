from sp_external_status_providers.models import ExternalStatusPage, ExternalStatusComponent


def sync_external_status_pages():
    components_to_delete = list(ExternalStatusComponent.objects.all())

    pages = ExternalStatusPage.objects.all()
    for page in pages:
        provider = page.provider_class(page)
        components = provider.get_components()

        groups = {}
        for component in components:
            if component['group']:
                groups[component['id']] = component

        for component in components:
            if not component['group']:
                c = ExternalStatusComponent.by_object_id(component['id'])
                if c:
                    components_to_delete.remove(c)
                if not c:
                    c = ExternalStatusComponent()
                    c.page_object_id = component['id']
                    c.external_page = page
                c.name = component['name']
                if component['group_id']:
                    c.group_name = groups[component['group_id']]['name']
                else:
                    c.group_name = None
                c.save()

                if c.component:
                    c.component.status = ExternalStatusComponent.status(status_name=component['status'])
                    c.component.save()

    for m in components_to_delete:
        m.delete()


schedules = [(sync_external_status_pages, '* * * * *')]
