/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

import * as readline from "readline";
import Settings = require("./statuspage/models/Settings");
import SPImporter = require("./statuspage/SPImporter");

console.log(
    `Statuspage Import\n
This will import all Component Groups, Components and Metrics from your existing Statuspage.io page. Only Components in Component Groups will be added.\n
This can take some time...`)

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
})

const settings: Settings = {
    spio: {
        pageID: '',
        apiKey: ''
    },
    sp: {
        url: '',
        apiKey: ''
    }
};

rl.question('Statuspage.io Page ID: ', answer => {
    if(answer == ''){
        console.error('No value provided. Restart the Script.')
        return
    }
    settings.spio.pageID = answer

    rl.question('Statuspage.io API Key: ', answer => {
        if(answer == ''){
            console.error('No value provided. Restart the Script.')
            return
        }
        settings.spio.apiKey = answer

        rl.question('Status-Page API URL: ', answer => {
            if(answer == ''){
                console.error('No value provided. Restart the Script.')
                return
            }
            settings.sp.url = answer

            rl.question('Status-Page API Key: ', answer => {
                if(answer == ''){
                    console.error('No value provided. Restart the Script.')
                    return
                }
                settings.sp.apiKey = answer

                rl.question('Which data do you want to import? [0: All, 1: Components, 2: Metrics] ', answer => {
                    if(answer == ''){
                        console.error('No value provided. Restart the Script.')
                        return
                    }

                    new SPImporter(settings, parseInt(answer));
                })
            })
        })
    })
})
