<a name="unreleased"></a>
## [Unreleased]


<a name="v1.8.3"></a>
## [v1.8.3] - 2021-06-18
### Bug Fixes
- **Installer:** Fix Role not Found ([e1b489e](https://github.com/Status-Page/Status-Page/commit/e1b489eac5b8edd7ff5d811c2936c03ee4d18e50))

### Build
- **deps:** bump typescript from 4.3.2 to 4.3.4 ([#90](https://github.com/Status-Page/Status-Page/issues/90)) ([ff9c805](https://github.com/Status-Page/Status-Page/commit/ff9c805b88a391d8cb00226eaf369e979df39636))
- **deps:** bump symfony/process from 5.3.0 to 5.3.2 ([#89](https://github.com/Status-Page/Status-Page/issues/89)) ([343a9f0](https://github.com/Status-Page/Status-Page/commit/343a9f0f8b539d1a0195625149144fbd83f26121))
- **deps-dev:** bump laravel-mix from 6.0.20 to 6.0.22 ([#88](https://github.com/Status-Page/Status-Page/issues/88)) ([374ffb0](https://github.com/Status-Page/Status-Page/commit/374ffb049f3abec1a5bd012a605f137eb2897e02))
- **deps-dev:** bump tailwindcss from 2.1.4 to 2.2.0 ([#91](https://github.com/Status-Page/Status-Page/issues/91)) ([6aa76f1](https://github.com/Status-Page/Status-Page/commit/6aa76f1b661ca0393c5dadb6cf46fec29f24c9d1))
- **deps-dev:** bump postcss from 8.3.4 to 8.3.5 ([#92](https://github.com/Status-Page/Status-Page/issues/92)) ([928dafc](https://github.com/Status-Page/Status-Page/commit/928dafcf74b1e487212a7dd768b30de4f65a104a))


<a name="v1.8.2"></a>
## [v1.8.2] - 2021-06-17
### Bug Fixes
- **CachetImport:** 404s and not iterable data ([b7453e4](https://github.com/Status-Page/Status-Page/commit/b7453e4a7a580b47277729cb95fed192e088dfa8))


<a name="v1.8.1"></a>
## [v1.8.1] - 2021-06-16
### Bug Fixes
- **Subscribers:** Send Verification Mail only, when the user is not verified ([dad1b34](https://github.com/Status-Page/Status-Page/commit/dad1b3473ef488dc994ddbf5731bc96a2e487429))

### Features
- **IncidentsImport:** Add Incident Importer ([baf0a62](https://github.com/Status-Page/Status-Page/commit/baf0a621dd664a9bf8e87b23624b6958d20cdeb4))
- **SubscriberImport:** Add Subscriber Import Script ([055c9c9](https://github.com/Status-Page/Status-Page/commit/055c9c94aacc27eb54a730c0d67263a436397116))
- **Subscribers:** Add E-Mail Subscriptions ([#83](https://github.com/Status-Page/Status-Page/issues/83)) ([acd2a53](https://github.com/Status-Page/Status-Page/commit/acd2a53099c562048bebb690f804331bfeabd3cb))
- **Subscribers:** Add E-Mail Subscriptions ([5f306f4](https://github.com/Status-Page/Status-Page/commit/5f306f461a237be524dad203d067f20d7847e046))


<a name="v1.8.0"></a>
## [v1.8.0] - 2021-06-03
### Bug Fixes
- **AdminMetrics:** Changing collapse wont fail anymore, added missing validation (Closes: [#38](https://github.com/Status-Page/Status-Page/issues/38)) ([3835814](https://github.com/Status-Page/Status-Page/commit/3835814341b792810e0682ed3c32d7a9923609f7))
- **ComponentsAPI:** Description can be null ([bb37f77](https://github.com/Status-Page/Status-Page/commit/bb37f771de311cdd2c7aa9f0a9c95eb245f2d188))
- **HomeMetrics:** Fix values ([d5c9808](https://github.com/Status-Page/Status-Page/commit/d5c9808f2530ea4a858e1478976d1d510657ad1a))
- **MetricPoints:** Add missing orderBy ([62ad90f](https://github.com/Status-Page/Status-Page/commit/62ad90f5c46d6df4dc38fba946d5066bd55a23fa))
- **Metrics:** Faster Loading, no Caching (Closes: [#37](https://github.com/Status-Page/Status-Page/issues/37)) ([274a00e](https://github.com/Status-Page/Status-Page/commit/274a00e5816dffec267c6b6633dcf148d219bac2))
- **Version:** Version now gets fetched from GitHub ([4a27aa4](https://github.com/Status-Page/Status-Page/commit/4a27aa4e3fbeb0b6ac9d54d047be5eeadb6b4164))

### Build
- **deps:** bump ts-node from 9.1.1 to 10.0.0 ([#62](https://github.com/Status-Page/Status-Page/issues/62)) ([4a6b021](https://github.com/Status-Page/Status-Page/commit/4a6b021fa39652ec588dd4eff84b1d659a3dcac2))
- **deps:** bump doctrine/dbal from 3.0.0 to 3.1.0 ([#42](https://github.com/Status-Page/Status-Page/issues/42)) ([90a5516](https://github.com/Status-Page/Status-Page/commit/90a5516f8b7a2971d5485ca0bffedb1d8c6b2449))
- **deps:** bump typescript from 4.2.4 to 4.3.2 ([#68](https://github.com/Status-Page/Status-Page/issues/68)) ([f7ca3ec](https://github.com/Status-Page/Status-Page/commit/f7ca3ec51ec955183387b4354627b09a97b2993b))
- **deps:** bump symfony/process from 5.2.7 to 5.3.0 ([#67](https://github.com/Status-Page/Status-Page/issues/67)) ([89f5297](https://github.com/Status-Page/Status-Page/commit/89f5297bcdfbbc5338a34c4a851540d40a71b621))
- **deps:** bump symfony/process from 5.2.4 to 5.2.7 ([#53](https://github.com/Status-Page/Status-Page/issues/53)) ([9d2432f](https://github.com/Status-Page/Status-Page/commit/9d2432fd57bb6543010549829921e0927662729c))
- **deps:** bump configcat/configcat-client from 5.2.0 to 5.2.1 ([#66](https://github.com/Status-Page/Status-Page/issues/66)) ([64baa58](https://github.com/Status-Page/Status-Page/commit/64baa582463e2f4473c166deb132d1b6f4c83a6b))
- **deps:** bump laravel/framework from 8.37.0 to 8.44.0 ([#65](https://github.com/Status-Page/Status-Page/issues/65)) ([998062f](https://github.com/Status-Page/Status-Page/commit/998062fa40a7e83968c4d594df8b25778253d70f))
- **deps:** bump laravel/framework from 8.36.2 to 8.37.0 ([#41](https://github.com/Status-Page/Status-Page/issues/41)) ([b6a84a0](https://github.com/Status-Page/Status-Page/commit/b6a84a0d6045c16e3878810768122c91854f755d))
- **deps-dev:** bump postcss-import from 14.0.1 to 14.0.2 ([#57](https://github.com/Status-Page/Status-Page/issues/57)) ([9473fe4](https://github.com/Status-Page/Status-Page/commit/9473fe4f843fabac03566b14881a560e740eb405))
- **deps-dev:** bump [@tailwindcss](https://github.com/tailwindcss)/typography from 0.4.0 to 0.4.1 ([#63](https://github.com/Status-Page/Status-Page/issues/63)) ([f68f9d8](https://github.com/Status-Page/Status-Page/commit/f68f9d87d31fe904a7642714b852963e3f8e1582))
- **deps-dev:** bump laravel-mix from 6.0.18 to 6.0.19 ([#55](https://github.com/Status-Page/Status-Page/issues/55)) ([6c7c937](https://github.com/Status-Page/Status-Page/commit/6c7c937258e207beaac1173fef90def0dabc33b5))
- **deps-dev:** bump postcss from 8.2.13 to 8.2.14 ([#54](https://github.com/Status-Page/Status-Page/issues/54)) ([17a890c](https://github.com/Status-Page/Status-Page/commit/17a890c09617588f44d85751cb932a4c8dad6b3c))
- **deps-dev:** bump postcss from 8.2.14 to 8.3.0 ([#61](https://github.com/Status-Page/Status-Page/issues/61)) ([d90d0ad](https://github.com/Status-Page/Status-Page/commit/d90d0ad1ce1c1ffe3df98d0d06b9c1dd0119cdb2))
- **deps-dev:** bump laravel-mix from 6.0.16 to 6.0.18 ([#45](https://github.com/Status-Page/Status-Page/issues/45)) ([7c28aec](https://github.com/Status-Page/Status-Page/commit/7c28aec5123ef4b1cc3ace504fcef5fece29b13f))
- **deps-dev:** bump tailwindcss from 2.1.1 to 2.1.2 ([#47](https://github.com/Status-Page/Status-Page/issues/47)) ([f5d6ae0](https://github.com/Status-Page/Status-Page/commit/f5d6ae07ef17ebfa91cdd84a9875d71e21d279d6))
- **deps-dev:** bump tailwindcss from 2.1.2 to 2.1.3 ([#69](https://github.com/Status-Page/Status-Page/issues/69)) ([300debe](https://github.com/Status-Page/Status-Page/commit/300debe008038103fb05df9ab90a210d53a76ac3))
- **deps-dev:** bump postcss from 8.2.10 to 8.2.13 ([#48](https://github.com/Status-Page/Status-Page/issues/48)) ([6b81be5](https://github.com/Status-Page/Status-Page/commit/6b81be5054784e5382ace82a90c42eb8e988dd38))
- **deps-dev:** bump autoprefixer from 10.2.5 to 10.2.6 ([#70](https://github.com/Status-Page/Status-Page/issues/70)) ([b0ea194](https://github.com/Status-Page/Status-Page/commit/b0ea1948760dc697ca8e16bb66054a3a50217e08))

### Code Update
- **Settings:** Remove metrics_cache from Settings ([5040037](https://github.com/Status-Page/Status-Page/commit/504003729ca4fefb1f760feb8eb6cd6f60b5e50d))

### Features
- **LinkedPages:** Pre-Release of the Linked Status Feature ([c2f5929](https://github.com/Status-Page/Status-Page/commit/c2f5929fdc4d9efa24e1c51d5ef341e51301f840))


<a name="v1.7.6"></a>
## [v1.7.6] - 2021-04-30
### Build
- **deps:** bump laravel/framework from 8.37.0 to 8.40.0 ([#51](https://github.com/Status-Page/Status-Page/issues/51)) ([802c5c2](https://github.com/Status-Page/Status-Page/commit/802c5c2225dcd019188c304dae3312672f3fbc1b))


<a name="v1.7.5"></a>
## [v1.7.5] - 2021-04-16
### Bug Fixes
- **ComponentsAPI:** Description can be null ([346ae9d](https://github.com/Status-Page/Status-Page/commit/346ae9dce9159469ddbdf9001aae8548ef66397e))
- **HomeMetrics:** Fix values ([b5bc418](https://github.com/Status-Page/Status-Page/commit/b5bc418411cbb574434f034a20f48494de08e322))
- **MetricPoints:** Add missing orderBy ([ea1f665](https://github.com/Status-Page/Status-Page/commit/ea1f665eaec351916e2d7a367fbe03b1c11b632c))

### Build
- **deps:** bump laravel/framework from 8.36.2 to 8.37.0 ([#41](https://github.com/Status-Page/Status-Page/issues/41)) ([53ae40f](https://github.com/Status-Page/Status-Page/commit/53ae40ff9c877d15f173e626a58c37653d83a1b9))

### Code Update
- **Settings:** Remove metrics_cache from Settings ([0e4ac79](https://github.com/Status-Page/Status-Page/commit/0e4ac795a85cfc0026655ff8ecc4bf1c2f7ffd3b))


<a name="v1.7.4"></a>
## [v1.7.4] - 2021-04-12
### Bug Fixes
- **AdminMetrics:** Changing collapse wont fail anymore, added missing validation (Closes: [#38](https://github.com/Status-Page/Status-Page/issues/38)) ([01179ad](https://github.com/Status-Page/Status-Page/commit/01179ad0baf733b4bee79e3bf2e101fe32ea2aa1))
- **Metrics:** Faster Loading, no Caching (Closes: [#37](https://github.com/Status-Page/Status-Page/issues/37)) ([79604d9](https://github.com/Status-Page/Status-Page/commit/79604d9bdd7175550c344d09343980583796fae7))

### Build
- **deps-dev:** bump nunomaduro/collision from 5.3.0 to 5.4.0 ([#35](https://github.com/Status-Page/Status-Page/issues/35)) ([88c235f](https://github.com/Status-Page/Status-Page/commit/88c235f340bb6ce77f76e697ed2be36eae8f20f8))
- **deps-dev:** bump postcss from 8.2.9 to 8.2.10 ([#36](https://github.com/Status-Page/Status-Page/issues/36)) ([c3f1b32](https://github.com/Status-Page/Status-Page/commit/c3f1b32dd47cbd6d02c0688d6564eb46cbfc306a))


<a name="v1.7.3"></a>
## [v1.7.3] - 2021-04-12
### Code Update
- **Caching:** Add Log outputs ([161654b](https://github.com/Status-Page/Status-Page/commit/161654bd73e3046bde9d36b604e866d29ac4411c))


<a name="v1.7.2"></a>
## [v1.7.2] - 2021-04-11
### Bug Fixes
- **UptimeRobot:** Maintenance Windows should work correctly now ([5595837](https://github.com/Status-Page/Status-Page/commit/55958374bc94bf583d9e84fac69ccab33ccea2b7))

### Features
- **Metrics:** Add 15 Minute interval ([57127e0](https://github.com/Status-Page/Status-Page/commit/57127e030c09344ae991f07711a54b0dccaa6cce))


<a name="v1.7.1"></a>
## [v1.7.1] - 2021-04-10
### Bug Fixes
- **UptimeRobot:** Add Listeners to Components ([c066d17](https://github.com/Status-Page/Status-Page/commit/c066d1713836ca4e75f6b51e0d4b78db463c56aa))


<a name="v1.7.0"></a>
## [v1.7.0] - 2021-04-10
### Features
- **Metrics:** Metrics are now collapsable ([ab30a5a](https://github.com/Status-Page/Status-Page/commit/ab30a5ab73e8a96d67957b057580422b387c11ea))
- **RunCron:** Run task scheduler externally ([baa1cae](https://github.com/Status-Page/Status-Page/commit/baa1cae022cb41b52b9426457fd5971d3d2a0905))
- **UptimeRobot:** Check for active Maintenance Windows ([2e5c19f](https://github.com/Status-Page/Status-Page/commit/2e5c19f3bb0f2a54a735396515d865b624e521f2))
- **i18n:** Add Translation strings for 'Home' ([70f1c8e](https://github.com/Status-Page/Status-Page/commit/70f1c8ed4bb6ca14c1b00e3d92ed609b9a1db531))


<a name="v1.6.5"></a>
## [v1.6.5] - 2021-04-10
### Bug Fixes
- **Metrics:** Increase the Interval for the Cache ([0717481](https://github.com/Status-Page/Status-Page/commit/07174812464f8cdb9ba680ce93ad5c7a1047a5bc))
- **UptimeRobot:** Add UR Status to Table ([c8f099d](https://github.com/Status-Page/Status-Page/commit/c8f099dab4454edafce149029dadcc62911890f9))


<a name="v1.6.4"></a>
## [v1.6.4] - 2021-04-10
### Bug Fixes
- **ComponentSelection:** "1" after each ComponentGroup name ([fb91d7d](https://github.com/Status-Page/Status-Page/commit/fb91d7ddb6eaeb77351f11ab1186b6dbcb3dd672))
- **MobileNavigation:** Add missing link to UR ([f0b33b0](https://github.com/Status-Page/Status-Page/commit/f0b33b0a2b160a94b37aaf604f8d47007c29e9bc))


<a name="v1.6.3"></a>
## [v1.6.3] - 2021-04-10
### Bug Fixes
- **Updater:** Remove seeder.... ([662eadd](https://github.com/Status-Page/Status-Page/commit/662eadd9f4a8579168fad6924db3d34c4865d8c6))


<a name="v1.6.2"></a>
## [v1.6.2] - 2021-04-10
### Bug Fixes
- **Update:** The updater shouldn't get stuck... ([9919193](https://github.com/Status-Page/Status-Page/commit/9919193fa136259b7672c7ad6da267b6ca12cc6f))


<a name="v1.6.1"></a>
## [v1.6.1] - 2021-04-10
### Bug Fixes
- **Update:** Update shouldn't get stuck in the migrations now ([4fc1c26](https://github.com/Status-Page/Status-Page/commit/4fc1c26e6ed3a297d6432a87b5676ea93b7a83e3))


<a name="v1.6.0"></a>
## [v1.6.0] - 2021-04-10
### Bug Fixes
- **Database:** Split up Seeders ([a02964e](https://github.com/Status-Page/Status-Page/commit/a02964e24a4b2c22c7c3733cdcf1a2c2f66eaf51))
- **Incidents:** Texts can now be longer ([#33](https://github.com/Status-Page/Status-Page/issues/33)) ([319cfc3](https://github.com/Status-Page/Status-Page/commit/319cfc33819027e9a72e7558bd4a1a2f574e0517))
- **ManagedComment:** Changed spelling ([f48fc0f](https://github.com/Status-Page/Status-Page/commit/f48fc0f5a4c2f3e58772b4ac4e8db74a7674e7e3))
- **Metrics:** Possible fix for the Metric Caching ([6d18909](https://github.com/Status-Page/Status-Page/commit/6d18909fb48df79fe071bf7afb769514a0d79a12))
- **Settings:** Make Checkbox bigger ([fb4870b](https://github.com/Status-Page/Status-Page/commit/fb4870bea7dad7be3000276db33ce100338d2a6f))
- **Statuses:** Update Colors for better contrast ([d6a7cc4](https://github.com/Status-Page/Status-Page/commit/d6a7cc410247ce48e803f04da25123a4b3c14915))
- **Statuses:** Correct the Strings ([78a4392](https://github.com/Status-Page/Status-Page/commit/78a439265e18797ff464951f1f1c55bbb0c38096))

### Build
- **deps:** bump laravel/framework from 8.36.1 to 8.36.2 ([#32](https://github.com/Status-Page/Status-Page/issues/32)) ([39f84cd](https://github.com/Status-Page/Status-Page/commit/39f84cd42bb96e2442ee2e567ddaad9104e9f4e8))
- **deps:** bump typescript from 4.2.3 to 4.2.4 ([#31](https://github.com/Status-Page/Status-Page/issues/31)) ([087b093](https://github.com/Status-Page/Status-Page/commit/087b09304508b2f033847eada07d200d428d69cd))
- **deps:** bump laravel/framework from 8.34.0 to 8.36.1 ([#30](https://github.com/Status-Page/Status-Page/issues/30)) ([15a7550](https://github.com/Status-Page/Status-Page/commit/15a7550474e3fa80e147790b626fdf9a51655a3e))
- **deps:** bump predis/predis from 1.1.6 to 1.1.7 ([#27](https://github.com/Status-Page/Status-Page/issues/27)) ([ea007e9](https://github.com/Status-Page/Status-Page/commit/ea007e951105a6b716fa74d38a0adcbd202717d7))
- **deps-dev:** bump tailwindcss from 2.0.4 to 2.1.1 ([#29](https://github.com/Status-Page/Status-Page/issues/29)) ([e1e9dea](https://github.com/Status-Page/Status-Page/commit/e1e9dea764da0b234cf2d2b5507b2932161c67e7))
- **deps-dev:** bump laravel-mix from 6.0.13 to 6.0.16 ([#28](https://github.com/Status-Page/Status-Page/issues/28)) ([cc72493](https://github.com/Status-Page/Status-Page/commit/cc72493368077b998fd1aecb008ed3a403b58ada))
- **deps-dev:** bump postcss-import from 14.0.0 to 14.0.1 ([#26](https://github.com/Status-Page/Status-Page/issues/26)) ([a6e50c9](https://github.com/Status-Page/Status-Page/commit/a6e50c91ee7585ad0b5106694f0b59dd9edbb59d))
- **deps-dev:** bump postcss from 8.2.8 to 8.2.9 ([#24](https://github.com/Status-Page/Status-Page/issues/24)) ([9fbc459](https://github.com/Status-Page/Status-Page/commit/9fbc459247f46361f93f31174e27f162af1188f4))
- **deps-dev:** bump fakerphp/faker from 1.13.0 to 1.14.1 ([#23](https://github.com/Status-Page/Status-Page/issues/23)) ([6b55a8d](https://github.com/Status-Page/Status-Page/commit/6b55a8d77bb28daae14acca25bb28ff648184d2f))
- **deps-dev:** bump [@tailwindcss](https://github.com/tailwindcss)/forms from 0.3.0 to 0.3.2 ([#22](https://github.com/Status-Page/Status-Page/issues/22)) ([9d2738e](https://github.com/Status-Page/Status-Page/commit/9d2738e7042f40ee20524a4e3303b5fb5ef37500))

### Features
- **UptimeRobot:** Added refresh button ([ad9fd6a](https://github.com/Status-Page/Status-Page/commit/ad9fd6a393f479a4fab566a0d62dfe07d5e9e24d))
- **UptimeRobot:** Added UptimeRobot as data source for component status and metrics ([c8516c3](https://github.com/Status-Page/Status-Page/commit/c8516c3db2eb8c4d5637ae658410de29cfc4ee54))
- **i18n:** Updated translations ([b8b6255](https://github.com/Status-Page/Status-Page/commit/b8b625531c6bcaaa08700acc5957a51c60939fb4))


<a name="v1.5.4"></a>
## [v1.5.4] - 2021-03-26
### Bug Fixes
- **metrics:** Removed long load Intervals ([9dce34c](https://github.com/Status-Page/Status-Page/commit/9dce34cdd1c4f92a94182b2e3454fb626b6f4762))

### Build
- **deps:** bump laravel/framework from 8.33.1 to 8.34.0 ([#20](https://github.com/Status-Page/Status-Page/issues/20)) ([b98defb](https://github.com/Status-Page/Status-Page/commit/b98defb0a19b06a0c8a8b0214a8df00823640194))
- **deps:** bump guzzlehttp/guzzle from 7.2.0 to 7.3.0 ([#19](https://github.com/Status-Page/Status-Page/issues/19)) ([4ecd027](https://github.com/Status-Page/Status-Page/commit/4ecd027560ee05852bcf067636577278773da9a1))
- **deps-dev:** bump [@tailwindcss](https://github.com/tailwindcss)/forms from 0.2.1 to 0.3.0 ([#21](https://github.com/Status-Page/Status-Page/issues/21)) ([55b8093](https://github.com/Status-Page/Status-Page/commit/55b8093047e9e141c5f1e655723574208efef916))
- **deps-dev:** bump alpinejs from 2.8.1 to 2.8.2 ([#18](https://github.com/Status-Page/Status-Page/issues/18)) ([469eda2](https://github.com/Status-Page/Status-Page/commit/469eda2e7fa27fadd16d490364217a05ce60e425))
- **deps-dev:** bump phpunit/phpunit from 9.5.3 to 9.5.4 ([#17](https://github.com/Status-Page/Status-Page/issues/17)) ([ad927ca](https://github.com/Status-Page/Status-Page/commit/ad927ca3fc86cc8adc26ca431a73cd550c5ba65c))

### Features
- **update:** Add Version Note ([e6e5880](https://github.com/Status-Page/Status-Page/commit/e6e588084f7c747aea19aab14a9fb71db5e2c519))


<a name="v1.5.3"></a>
## [v1.5.3] - 2021-03-26
### Bug Fixes
- **metrics:** Possible fix for Overlapping Cache Jobs ([ad2644b](https://github.com/Status-Page/Status-Page/commit/ad2644b78543df4c8f994b9a2724b28095e99fdf))


<a name="v1.5.2"></a>
## [v1.5.2] - 2021-03-26
### Bug Fixes
- **metrics:** Possible fix for Overlapping Cache Jobs ([11cad32](https://github.com/Status-Page/Status-Page/commit/11cad32dd1ada7ebf439a34cc34ee3e3d6d5d317))


<a name="v1.5.1"></a>
## [v1.5.1] - 2021-03-26
### Bug Fixes
- **metrics:** Cache Metric Data, so Metrics should load faster ([9c36cbf](https://github.com/Status-Page/Status-Page/commit/9c36cbf376d32ef086a45db3b1b1393bef993ea6))
- **past:** Changed colspan for "No Results" ([eba879e](https://github.com/Status-Page/Status-Page/commit/eba879e90c511a5422f290f38b242688ad9a1acf))


<a name="v1.5.0"></a>
## [v1.5.0] - 2021-03-25
### Bug Fixes
- **darkmode:** Fix wrong Config request ([ee04c2c](https://github.com/Status-Page/Status-Page/commit/ee04c2c5c821e5499ecee008f63b49be0bbf1a79))
- **incidents:** Component Detaching and Attaching ([e45d738](https://github.com/Status-Page/Status-Page/commit/e45d73897cb051fce9d43d1dc322f6f5031982c0))
- **maintenances:** Component Detaching and Attaching ([d4f5998](https://github.com/Status-Page/Status-Page/commit/d4f599850c50a3584b143e6bdf6d7392d12ae3a8))
- **metrics:** Fixed wrong Config request ([e21095a](https://github.com/Status-Page/Status-Page/commit/e21095a35833ae59f8669678992a2a16a4663051))
- **scripts:** Add missing scripts ([292040e](https://github.com/Status-Page/Status-Page/commit/292040efb553d0fb862dd274d30a83225e52559a))
- **settings:** Remove obsolete Settings ([f8ec079](https://github.com/Status-Page/Status-Page/commit/f8ec0799b63035afb526ac4d7bdeb63afc0b2e00))

### Code Refactoring
- **home:** Refactoring some code ([fde83db](https://github.com/Status-Page/Status-Page/commit/fde83dbd0751b0b6d81bc8e4ce686a5f0181d5da))

### Code Update
- **footer:** Add Footer with Copyright and Link to GitHub ([f2e011e](https://github.com/Status-Page/Status-Page/commit/f2e011e9e0ae3bb24ec1f57455b61f74456d1f1d))

### Features
- **i18n:** Add Settings translation Strings ([dce45d4](https://github.com/Status-Page/Status-Page/commit/dce45d486b872e2cc6d718424739a15996a9e565))
- **incidents:** Update Incidents without Message ([b801820](https://github.com/Status-Page/Status-Page/commit/b801820ece124506800f9d5173b3da22ccbbee76))
- **maintenances:** Update Maintenances without Message ([7cb6875](https://github.com/Status-Page/Status-Page/commit/7cb6875ce0b8011526968d0185c0d3d85cb6caaa))
- **past:** Change Incident / Maintenance Visibility inline ([76e17da](https://github.com/Status-Page/Status-Page/commit/76e17da045ce1b221d3e3eb18421fe48a87873c6))
- **settings:** Added Settings Page ([99b67c8](https://github.com/Status-Page/Status-Page/commit/99b67c8fd1c5d81028bcfbf45b628e326edb1fcf))


<a name="v1.4.4"></a>
## [v1.4.4] - 2021-03-19
### Bug Fixes
- **darkmode:** metric title is now shown in light mode ([547bad3](https://github.com/Status-Page/Status-Page/commit/547bad31de471d6969370dfeacc1db658e1f7121))

### Features
- **cachet_import:** Add Cachet Importer ([01ad848](https://github.com/Status-Page/Status-Page/commit/01ad848d4e254e79ee6f64501968fd048f213c59))
- **home:** Data gets refreshed every 10s ([f208af8](https://github.com/Status-Page/Status-Page/commit/f208af8468318d3c56521822453cbe327152ff1b))


<a name="v1.4.3"></a>
## [v1.4.3] - 2021-03-18
### Bug Fixes
- **metrics:** Defer loading and add loading animation ([af2295e](https://github.com/Status-Page/Status-Page/commit/af2295e4460c6c3aac75c9f75e816f48ed3260bb))


<a name="v1.4.2"></a>
## [v1.4.2] - 2021-03-18
### Features
- **darkmode:** Use can now activate Darkmode ([bfd5f6e](https://github.com/Status-Page/Status-Page/commit/bfd5f6e73fbebdc697f8a4f4a6d2a3bb88d1d40b))
- **darkmode:** Added Darkmode classes ([875aa7f](https://github.com/Status-Page/Status-Page/commit/875aa7f1f8411174c6145e7fa8de7cfbb15e9cf4))


<a name="v1.4.1"></a>
## [v1.4.1] - 2021-03-18
### Bug Fixes
- **logo:** Add Logo ([f7186b8](https://github.com/Status-Page/Status-Page/commit/f7186b8f66b3922c650a54679bf2894108c32eed))
- **searchbar_strings:** Fixed wrong Strings ([4ba1a75](https://github.com/Status-Page/Status-Page/commit/4ba1a75baeae9f5aa9e827c635edc65e5ceeda9a))

### Reverts
- Changelog


<a name="v1.4.0"></a>
## [v1.4.0] - 2021-03-18
### Bug Fixes
- **css:** Wrong CSS styling ([cf03190](https://github.com/Status-Page/Status-Page/commit/cf03190c58c2077d31104e43d52a2fae14ecb078))
- **data:** Data gets reloaded without page refresh ([52471f5](https://github.com/Status-Page/Status-Page/commit/52471f582016031b5af5bbc2e22bcf6f4732421e))
- **maintenance_add:** Texts are now not only uppercase ([efd1f55](https://github.com/Status-Page/Status-Page/commit/efd1f55e8292159ffcc043e3ba419c5ee33f4503))
- **maintenances:** No results now styled correctly ([002800b](https://github.com/Status-Page/Status-Page/commit/002800b1c8baa71d9c2d74e23c2b53aeb736b13d))
- **metrics_add:** Texts are now not only uppercase ([70e5a2c](https://github.com/Status-Page/Status-Page/commit/70e5a2c6ee8774e3e521a966f219f5b638e851bd))
- **no_results:** Add missing no results ([d7f19e9](https://github.com/Status-Page/Status-Page/commit/d7f19e9b2e43003dd0d7f8e5cf4d0907c69d3889))
- **search:** Reset page to one, on search ([1f9826a](https://github.com/Status-Page/Status-Page/commit/1f9826abbca53514d4d028a6c1e275e67461ddef))
- **users_add:** Texts are now not only uppercase ([0c845a0](https://github.com/Status-Page/Status-Page/commit/0c845a044e2d6a14f36856652e9330848258dbf7))

### Features
- **action_log:** Make Action Log view Livewire Component ([045a67b](https://github.com/Status-Page/Status-Page/commit/045a67b3a95093f2395386083f4455aead0e28f5))
- **chore:** Add Per Page selector ([01eef44](https://github.com/Status-Page/Status-Page/commit/01eef4410870d87d6091afc856027ed8f6952d21))
- **incidens:** User can choose between updating component status or not ([051be18](https://github.com/Status-Page/Status-Page/commit/051be18f391c49e8feb121012a9d2e320e718ec2))
- **past_maintenances:** Add Scheduled At and End At to past incidents ([b93cc24](https://github.com/Status-Page/Status-Page/commit/b93cc241cd6f813863b7916a2d4825c73758f97e))

### Performance Improvements
- **updater:** Updater improvements ([584d967](https://github.com/Status-Page/Status-Page/commit/584d9678601a812b4fb1504b432676ab1327bb95))


<a name="v1.3.4"></a>
## [v1.3.4] - 2021-03-15
### Bug Fixes
- **home_components:** Dark Mode collapse Button color ([986ec0d](https://github.com/Status-Page/Status-Page/commit/986ec0d90007c144991e9ab8d1b28a7f8a2471f0))
- **metrics:** made element points smaller ([dc6dd2d](https://github.com/Status-Page/Status-Page/commit/dc6dd2d6e4579fd9cb4c8931d8a132538e2ffb91))

### Code Refactoring
- **components:** Livewire Components, Pagination, etc Part 3 ([f974fab](https://github.com/Status-Page/Status-Page/commit/f974fab0909cd196c7e8569974a86edb49d93905))
- **components:** Some Searching ([a3e36de](https://github.com/Status-Page/Status-Page/commit/a3e36de3336f96ca4e5054cfde16906fa2830ae3))
- **components:** Livewire Components, Pagination, etc Part 2 ([d685ae9](https://github.com/Status-Page/Status-Page/commit/d685ae983015409199a26a1f0816b651b94ee09b))
- **components:** Some Searching ([3f5a6cd](https://github.com/Status-Page/Status-Page/commit/3f5a6cdfd3ef696a42491def536119eefb8f448f))
- **styles:** Livewire Components, Pagination, etc Part 2 ([288d94b](https://github.com/Status-Page/Status-Page/commit/288d94b0e3f084b64291bbb5f02bdbd393064673))
- **styles:** Livewire Components, Pagination, etc ([b6332ab](https://github.com/Status-Page/Status-Page/commit/b6332abcceda30f0c2c855b46abc4bb06e52280b))

### Features
- **darkmode:** Darkmode for main Layout ([c8e3cb0](https://github.com/Status-Page/Status-Page/commit/c8e3cb06976248d7abd15e1a32582f5f6ee6daf3))
- **i18n:** Add Status Language lines ([a75417f](https://github.com/Status-Page/Status-Page/commit/a75417fd84d392af95b0fd11f7b581474f675759))
- **incidents:** Markdown Support ([194dc19](https://github.com/Status-Page/Status-Page/commit/194dc194e2b74f2aeb31d5c682289a41c25b55e7))


<a name="v1.3.3"></a>
## [v1.3.3] - 2021-03-13
### Bug Fixes
- **chore:** Bump Version to v1.3.3 ([05015c8](https://github.com/Status-Page/Status-Page/commit/05015c8e962d0bdd85b0d51dc2dfe5d710a3cf82))

### Features
- **metric_interval:** Preparation for Metric Intervals ([c6bd91d](https://github.com/Status-Page/Status-Page/commit/c6bd91d7e231208e04cd6dc52419e2c870db729d))


<a name="v1.3.2"></a>
## [v1.3.2] - 2021-03-13
### Bug Fixes
- **actionlog:** Wrong Action on Metric Edit in Action Log ([4975e7d](https://github.com/Status-Page/Status-Page/commit/4975e7df13082c6fe7d41d00aa24eaf8a5ddb936))
- **chore:** Bump version ([fb55282](https://github.com/Status-Page/Status-Page/commit/fb55282b6bd338e23626a0ae772f8541c52271e6))
- **config_cat:** Make Page ID only available for super admins ([dfd7e67](https://github.com/Status-Page/Status-Page/commit/dfd7e67592828e462a0727b19ce07516ca72911e))


<a name="v1.3.1"></a>
## [v1.3.1] - 2021-03-12

<a name="v1.3.0"></a>
## [v1.3.0] - 2021-03-12

<a name="v1.2.8"></a>
## [v1.2.8] - 2021-03-12

<a name="v1.2.7"></a>
## [v1.2.7] - 2021-03-12

<a name="v1.2.6"></a>
## [v1.2.6] - 2021-03-12

<a name="v1.2.5"></a>
## [v1.2.5] - 2021-03-12

<a name="v1.2.4"></a>
## [v1.2.4] - 2021-03-09

<a name="v1.2.3"></a>
## [v1.2.3] - 2021-03-09

<a name="v1.2.2"></a>
## [v1.2.2] - 2021-03-09

<a name="v1.2.1"></a>
## [v1.2.1] - 2021-03-07

<a name="v1.2.0"></a>
## [v1.2.0] - 2021-03-07

<a name="v1.1.3"></a>
## [v1.1.3] - 2021-02-23

<a name="v1.1.2"></a>
## [v1.1.2] - 2021-02-22

<a name="v1.1.1"></a>
## [v1.1.1] - 2021-02-22

<a name="v1.1.0"></a>
## [v1.1.0] - 2021-02-22

<a name="v1.0.2"></a>
## [v1.0.2] - 2021-02-21

<a name="v1.0.1"></a>
## [v1.0.1] - 2021-02-21

<a name="v1.0"></a>
## [v1.0] - 2021-02-21

<a name="v1.0.0"></a>
## v1.0.0 - 2021-02-21

[Unreleased]: https://github.com/Status-Page/Status-Page/compare/v1.8.3...HEAD
[v1.8.3]: https://github.com/Status-Page/Status-Page/compare/v1.8.2...v1.8.3
[v1.8.2]: https://github.com/Status-Page/Status-Page/compare/v1.8.1...v1.8.2
[v1.8.1]: https://github.com/Status-Page/Status-Page/compare/v1.8.0...v1.8.1
[v1.8.0]: https://github.com/Status-Page/Status-Page/compare/v1.7.6...v1.8.0
[v1.7.6]: https://github.com/Status-Page/Status-Page/compare/v1.7.5...v1.7.6
[v1.7.5]: https://github.com/Status-Page/Status-Page/compare/v1.7.4...v1.7.5
[v1.7.4]: https://github.com/Status-Page/Status-Page/compare/v1.7.3...v1.7.4
[v1.7.3]: https://github.com/Status-Page/Status-Page/compare/v1.7.2...v1.7.3
[v1.7.2]: https://github.com/Status-Page/Status-Page/compare/v1.7.1...v1.7.2
[v1.7.1]: https://github.com/Status-Page/Status-Page/compare/v1.7.0...v1.7.1
[v1.7.0]: https://github.com/Status-Page/Status-Page/compare/v1.6.5...v1.7.0
[v1.6.5]: https://github.com/Status-Page/Status-Page/compare/v1.6.4...v1.6.5
[v1.6.4]: https://github.com/Status-Page/Status-Page/compare/v1.6.3...v1.6.4
[v1.6.3]: https://github.com/Status-Page/Status-Page/compare/v1.6.2...v1.6.3
[v1.6.2]: https://github.com/Status-Page/Status-Page/compare/v1.6.1...v1.6.2
[v1.6.1]: https://github.com/Status-Page/Status-Page/compare/v1.6.0...v1.6.1
[v1.6.0]: https://github.com/Status-Page/Status-Page/compare/v1.5.4...v1.6.0
[v1.5.4]: https://github.com/Status-Page/Status-Page/compare/v1.5.3...v1.5.4
[v1.5.3]: https://github.com/Status-Page/Status-Page/compare/v1.5.2...v1.5.3
[v1.5.2]: https://github.com/Status-Page/Status-Page/compare/v1.5.1...v1.5.2
[v1.5.1]: https://github.com/Status-Page/Status-Page/compare/v1.5.0...v1.5.1
[v1.5.0]: https://github.com/Status-Page/Status-Page/compare/v1.4.4...v1.5.0
[v1.4.4]: https://github.com/Status-Page/Status-Page/compare/v1.4.3...v1.4.4
[v1.4.3]: https://github.com/Status-Page/Status-Page/compare/v1.4.2...v1.4.3
[v1.4.2]: https://github.com/Status-Page/Status-Page/compare/v1.4.1...v1.4.2
[v1.4.1]: https://github.com/Status-Page/Status-Page/compare/v1.4.0...v1.4.1
[v1.4.0]: https://github.com/Status-Page/Status-Page/compare/v1.3.4...v1.4.0
[v1.3.4]: https://github.com/Status-Page/Status-Page/compare/v1.3.3...v1.3.4
[v1.3.3]: https://github.com/Status-Page/Status-Page/compare/v1.3.2...v1.3.3
[v1.3.2]: https://github.com/Status-Page/Status-Page/compare/v1.3.1...v1.3.2
[v1.3.1]: https://github.com/Status-Page/Status-Page/compare/v1.3.0...v1.3.1
[v1.3.0]: https://github.com/Status-Page/Status-Page/compare/v1.2.8...v1.3.0
[v1.2.8]: https://github.com/Status-Page/Status-Page/compare/v1.2.7...v1.2.8
[v1.2.7]: https://github.com/Status-Page/Status-Page/compare/v1.2.6...v1.2.7
[v1.2.6]: https://github.com/Status-Page/Status-Page/compare/v1.2.5...v1.2.6
[v1.2.5]: https://github.com/Status-Page/Status-Page/compare/v1.2.4...v1.2.5
[v1.2.4]: https://github.com/Status-Page/Status-Page/compare/v1.2.3...v1.2.4
[v1.2.3]: https://github.com/Status-Page/Status-Page/compare/v1.2.2...v1.2.3
[v1.2.2]: https://github.com/Status-Page/Status-Page/compare/v1.2.1...v1.2.2
[v1.2.1]: https://github.com/Status-Page/Status-Page/compare/v1.2.0...v1.2.1
[v1.2.0]: https://github.com/Status-Page/Status-Page/compare/v1.1.3...v1.2.0
[v1.1.3]: https://github.com/Status-Page/Status-Page/compare/v1.1.2...v1.1.3
[v1.1.2]: https://github.com/Status-Page/Status-Page/compare/v1.1.1...v1.1.2
[v1.1.1]: https://github.com/Status-Page/Status-Page/compare/v1.1.0...v1.1.1
[v1.1.0]: https://github.com/Status-Page/Status-Page/compare/v1.0.2...v1.1.0
[v1.0.2]: https://github.com/Status-Page/Status-Page/compare/v1.0.1...v1.0.2
[v1.0.1]: https://github.com/Status-Page/Status-Page/compare/v1.0...v1.0.1
[v1.0]: https://github.com/Status-Page/Status-Page/compare/v1.0.0...v1.0
