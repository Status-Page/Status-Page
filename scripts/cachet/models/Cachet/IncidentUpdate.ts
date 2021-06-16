/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

class IncidentUpdate {
    id: number
    incident_id: number
    status: number
    message: string
    user_id: number
    created_at: string
    updated_at: string
    human_status: string
    permalink: string
}

export = IncidentUpdate
