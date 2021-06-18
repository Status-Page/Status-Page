/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

import * as readline from "readline";
import Settings = require("./cachet/models/Settings");
import CachetImporter = require("./cachet/CachetImporter");

console.log(
    `Statuspage Import\n
This will import all Component Groups, Components and Metrics from your existing Cachet Installation.\n
This can take some time...`)

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
})

const settings: Settings = {
    cachet: {
        domain: '',
        apiKey: ''
    },
    sp: {
        url: '',
        apiKey: ''
    }
};

rl.question('Cachet Domain (example: status.herrtxbias.net): ', answer => {
    if(answer == ''){
        console.error('No value provided. Restart the Script.')
        return
    }
    settings.cachet.domain = answer

    rl.question('API Key: ', answer => {
        if(answer == ''){
            console.error('No value provided. Restart the Script.')
            return
        }
        settings.cachet.apiKey = answer

        rl.question('Status-Page Domain  (example: status.herrtxbias.me): ', answer => {
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

                rl.question('Which data do you want to import? [0: All, 1: Components, 2: Metrics, 3: Incidents, 4: Subscribers] ', answer => {
                    if(answer == ''){
                        console.error('No value provided. Restart the Script.')
                        return
                    }

                    new CachetImporter(settings, parseInt(answer));
                })
            })
        })
    })
})
