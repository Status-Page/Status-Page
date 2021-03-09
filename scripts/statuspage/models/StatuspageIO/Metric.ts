/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

class Metric {
    id: string
    metrics_provider_id: string
    metric_identifier: string
    name: string
    display: true
    tooltip_description: string
    backfilled: true
    y_axis_min: number
    y_axis_max: number
    y_axis_hidden: true
    suffix: string
    decimal_places: number
    most_recent_data_at: string
    created_at: string
    updated_at: string
    last_fetched_at: string
    backfill_percentage: number
    reference_name: string
}

export = Metric
