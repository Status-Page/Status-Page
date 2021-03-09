/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

interface Component {
    id: string
    page_id: string
    group_id: string
    group: boolean
    name: string
    description: string
    position: number
    status: string
    showcase: boolean
    only_show_if_degraded: boolean
    automation_email: string
    start_date: string
    created_at: string
    updated_at: string
}

export = Component
