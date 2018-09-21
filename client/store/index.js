export const actions = {
    nuxtServerInit: async({
        dispatch
    }, context) => {
        return Promise.all([
            dispatch('video/nuxtServerInit', context),
            dispatch('channel/nuxtServerInit', context),
        ]);

    }

}