const webpack = require('webpack')
module.exports = {
  env: {
    baseUrl: process.env.BASE_URL || 'http://localhost:3000'
  },
  /*
   ** Headers of the page
   */
  head: {
    title: 'client',
    meta: [{
      charset: 'utf-8'
    }, {
      name: 'viewport',
      content: 'width=device-width, initial-scale=1'
    }, {
      hid: 'description',
      name: 'description',
      content: 'Nuxt.js project'
    }],
    link: [{
      rel: 'icon',
      type: 'image/x-icon',
      href: '/favicon.ico'
    }, {
      rel: 'stylesheet',
      href: 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'

    }]
  },
  /*
   ** Customize the progress bar color
   */
  loading: {
    color: '#3B8070'
  },
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/auth',
    '@nuxtjs/toast',
  ],
  toast: {
    position: 'top-right',
    duration: 800,
  },
  router: {
    middleware: []
  },
  plugins: [
    './plugins/mixins/user.js',
    './plugins/axios.js', {
      src: './plugins/video-player.js',
      ssr: false
    }, {
      src: './plugins/vee-validate.js',
      ssr: true
    },
  ],
  axios: {
    baseURL: 'http://127.0.0.1:8000/api',
    redirectError: {
      401: '/auth/login',
      500: '/'
    }
  },
  auth: {
    redirect: {
      login: '/auth/login'
    },
    strategies: {
      local: {
        endpoints: {
          login: {
            url: '/auth/login',
            method: 'post',
            propertyName: 'meta.token'
          },
          user: {
            url: '/user',
            method: 'get',
            propertyName: 'data'
          },
          logout: {
            url: '/auth/logout',
            method: 'post',
            propertyName: 'data'
          }
        }

      }
    }
  },
  css: [
    '~/assets/styles/app.scss',
    'video.js/dist/video-js.css',
  ],
  /*
   ** Build configuration
   */
  build: {
    plugins: [
      new webpack.ProvidePlugin({
        '_': 'lodash'
      })
    ],
    vendor: ['vee-validate'],
    /*
     ** Run ESLint on save
     */
    postcss: {
      plugins: {
        'postcss-custom-properties': false
      }
    },
    extend(config, {
      isDev,
      isClient
    }) {
      if (isDev && isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    }
  }
}