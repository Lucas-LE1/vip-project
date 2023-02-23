// vue.config.scripts

/**
 * @type {import('@vue/cli-service').ProjectOptions}
 */
module.exports = {
    baseURL: process.env.NODE_ENV === 'production'
        ? '/production-sub-path/'
        : '/'
}