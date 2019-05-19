/*
 *
 * VideoFilter reducer
 *
 */

import { fromJS } from 'immutable';
import { SET_RESULT_LIST, FETCH_YOUTUBE_VIDEOS } from './constants';

export const initialState = fromJS({
  options: [],
  loading: false,
  term: '',
});

function videoFilterReducer(state = initialState, action) {
  switch (action.type) {
    case SET_RESULT_LIST:
      console.log(action);
      return state.set('options', action.options).set('loading', false);
    case FETCH_YOUTUBE_VIDEOS:
      return state.set('loading', true).set('term', action.term);
    default:
      return state;
  }
}

export default videoFilterReducer;
