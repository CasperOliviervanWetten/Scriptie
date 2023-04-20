# CMOD 
CMOD is an alternative front-end for [CoRA](https://github.com/ArchitectureMining/CoRA), the coverability and reachability graph assistant.

# Installation
1. Download a release from the release tab.
2. Unzip.
3. Run `npm install` to install the required dependencies.
4. Configure CMOD according to your settings by editing `config.json` in the root folder.
5. Run `npm run build`. This might take a minute.
6. In the `dist` folder you will find the compiled files. Place these at your desired location.

# Acknowledgements
CMOD is built upon the [Vue framework](https://vuejs.org) and uses [Vuex](https://vuex.vuejs.org) for state management. In addition, CMOD makes use of [vue-class-component](https://github.com/vuejs/vue-class-component), [vue-property-decorator](https://github.com/kaorun343/vue-property-decorator), and [vuex-module-decorators](https://github.com/championswimmer/vuex-module-decorators). For the modeller CMOD uses [vue-multipane](https://github.com/yansern/vue-multipane) for the layout. [Vue-focus](https://github.com/simplesmiler/vue-focus) is used for setting focus.

