export default {
  request(state) {
    state.status = 'loading';
  },
  success(state, res) {
    state.status = 'success';
    const { data = {}, refs = {}, ...addons } = res.data;
    state.data = { ...data };
    state.refs = { ...refs };
    state.addons = { ...addons };
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
