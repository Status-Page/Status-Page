<a name="unreleased"></a>
## [Unreleased]


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

[Unreleased]: https://github.com/Status-Page/Status-Page/compare/v1.6.4...HEAD
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
