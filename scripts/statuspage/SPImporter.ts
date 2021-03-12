/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

import axios, {AxiosInstance} from "axios";
import Settings = require("./models/Settings");
import ComponentGroup = require("./models/StatuspageIO/ComponentGroup");
import Component = require("./models/StatuspageIO/Component");
import Metric = require("./models/StatuspageIO/Metric");

class SPImporter {
    private spio: AxiosInstance;
    private sp: AxiosInstance;

    public constructor(settings: Settings, importChoice: number = 0){
        console.log('Starting...')

        this.spio = axios.create({
            baseURL: `https://api.statuspage.io/v1/pages/${settings.spio.pageID}/`,
            headers: {
                'Authorization': `OAuth ${settings.spio.apiKey}`
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
            console.log(`Fetching Component Groups from statuspage.io`)
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
                description: group.description,
                visibility: true,
                order: group.position,
                collapse: 'expand_issue'
            })).data.data

            for (const comp of group.components) {
                try{
                    const component = (await this.spio.get<Component>(`/components/${comp}`)).data
                    await this.addComponent(component, componentGroup.id)
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
                status_id: 2,
                order: comp.position
            })).data.data
        }catch (e) {
            console.error(`Error: ${e.message}`)
        }
    }

    private async fetchMetrics() {
        try{
            console.log(`Fetching Metrics from statuspage.io`)
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
                visibility: metric.display
            })).data.data
        }catch (e) {
            console.error(`Error: ${e.message}`)
        }
    }
}

export = SPImporter;
