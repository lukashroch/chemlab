export default {
  set: (state, filter) => (state.data = { ...filter }),
  add: (state, filter) => (state.data = { ...state.data, ...filter }),
  clear: (state) => (state.data = {}),
};
