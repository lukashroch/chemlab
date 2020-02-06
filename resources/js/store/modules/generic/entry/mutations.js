export default {
  request(state) {
    state.status = 'loading';
  },
  success(state, res) {
    state.status = 'success';
    const { data } = res.data;
    state.data = Array.isArray(data) && !data.length ? {} : data;
    if ('refs' in res.data) state.refs = res.data.refs;
  },
  error(state, err) {
    const { status, statusText } = err.response;
    const { message } = err.response.data;
    state.error = {
      status,
      statusText,
      message
    };
    state.status = 'error';
  }
};
