export default function({
    store,
    redirect,
    route
}) {
    let channel = store.getters['channel/getChannel'](route.params.slug)
    let user = store.getters['auth/user']
    if (!channel || user.id != channel.user.id) {
        return redirect('/')
    }
}