import {
  mapGetters
} from 'vuex';
import Vue from 'vue'

const Validation = {
  install(Vue, options) {
    Vue.mixin({
      computed: {
        ...mapGetters({
          errors: 'validation/errors',
        })
      }
    })
  }
}

Vue.use(Validation)