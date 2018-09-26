export default function({
	$axios,
	store,
	redirect,
	app
}) {
	$axios.onError(error => {
		if (error.response && error.response.status == 422) {
			app.$toast.error('Invalid Data Supplied')
		}
		if (error.response && error.response.status == 500) {
			app.$toast.error('God ! , what did you do.. ')
		}
		if (error.response.status == 401) {
			app.$toast.error(error.response.data.message)
			redirect('/auth/login')
		}
		return Promise.reject(error)
	})
	$axios.onRequest((response) => {
		// let hasSuccess = _.some(response, res => _.has(res, "success"));
		// let hasMessage = _.some(response, res => _.has(res, "message"));
		// if (hasSuccess && hasMessage) {
		// 	app.$toast.success(response.data.message);
		// }
		// if (!hasSuccess && hasMessage) {
		// 	app.$toast.info(response.data.message);
		// }
		return response;
	})
}