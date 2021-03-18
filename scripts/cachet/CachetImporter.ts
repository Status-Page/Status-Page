/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

import axios, {AxiosInstance} from "axios";
import Settings = require("./models/Settings");
import ComponentGroup = require("./models/Cachet/ComponentGroup");
import Component = require("./models/Cachet/Component");
import Metric = require("./models/Cachet/Metric");

class CachetImporter {
    private spio: AxiosInstance;
    private sp: AxiosInstance;

    public constructor(settings: Settings, importChoice: number = 0){
        console.log('Starting...')

        this.spio = axios.create({
            baseURL: `https://${settings.cachet.domain}/api/v1`,
            headers: {
                'X-Cachet-Token': `${settings.cachet.apiKey}`
            }
        })

        this.sp = axios.create({
            baseURL: `${settings.sp.url}${settings.sp.url.endsWith('/') ? '' : '/'}`,
            headers: {
                'Authorization': `Bearer ${settings.sp.apiKey}`
            }
        })

        switch (importChoice){
            // All Data
            case 0:
                this.fetchComponentGroups().then(value => {
                    console.log('Successfully added all Components!')

                    this.fetchMetrics().then(value => {
                        console.log('Successfully added all Metrics!')
                    })
                })
                break

            // Components
            case 1:
                this.fetchComponentGroups().then(value => {
                    console.log('Successfully added all Components!')
                })
                break

            // Metrics
            case 2:
                this.fetchMetrics().then(value => {
                    console.log('Successfully added all Metrics!')
                })
                break
        }
    }

    private async fetchComponentGroups() {
        try{
            console.log(`Fetching Component Groups from Cachet`)
            const componentGroups = (await this.spio.get<Array<ComponentGroup>>('/component-groups')).data

            for(const group of componentGroups){
                await this.addComponentGroup(group)
            }
        }catch (e) {
            console.error(`Error: ${e.message}`)
        }
    }

    private async addComponentGroup(group: ComponentGroup) {
        try{
            const componentGroup = (await this.sp.post(`/component-groups`, {
                name: group.name,
                visibility: true,
                order: group.order,
                collapse: group.collapsed == 0 ? 'expand_always' : 'expand_issue'
            })).data.data

            const components = (await this.spio.get<Component[]>(`/components?group_id=${group.id}`)).data

            for (const comp of components) {
                try{
                    await this.addComponent(comp, componentGroup.id)
                }catch (e) {
                    console.error(`Error: ${e.message}`)
                }
            }
        }catch (e) {
            console.error(`Error: ${e.message}`)
        }
    }

    private async addComponent(comp: Component, groupID: number) {
        try{
            const component = (await this.sp.post(`/components`, {
                name: comp.name,
                description: comp.description,
                group: groupID,
                visibility: true,
                status_id: comp.status+1,
                link: comp.link,
                order: comp.order
            })).data.data
        }catch (e) {
            console.error(`Error: ${e.message}`)
        }
    }

    private async fetchMetrics() {
        try{
            console.log(`Fetching Metrics from Cachet`)
            const metrics = (await this.spio.get<Array<Metric>>('/metrics')).data

            for(const metric of metrics){
                await this.addMetric(metric)
            }
        }catch (e) {
            console.error(`Error: ${e.message}`)
        }
    }

    private async addMetric(metric: Metric) {
        try{
            const newMetric = (await this.sp.post(`/metrics`, {
                title: metric.name,
                suffix: metric.suffix,
                visibility: metric.display_chart
            })).data.data
        }catch (e) {
            console.error(`Error: ${e.message}`)
        }
    }
}

export = CachetImporter;
