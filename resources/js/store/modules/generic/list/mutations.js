export default {
  request(state) {
    state.status = 'loading';
  },
  success(state, res) {
    state.status = 'success';
    state.refs = res.data;
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
