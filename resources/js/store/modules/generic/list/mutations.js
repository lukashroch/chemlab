export default {
  request(state) {
    state.status = 'loading';
  },
  success(state, res) {
    state.status = 'success';
    state.refs = res.data;
  },
  error(state, err) {
    const { response: { status, statusText, data: { message } = {} } = {} } = err;
    state.error = {
      status,
      statusText,
      message,
    };
    state.status = 'error';
  },
};
