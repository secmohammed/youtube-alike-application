export default function({
    redirect,
    route
}) {
    if (!route.query.token) {
        return redirect('/')
    }
}