/*
 *
 * ListPage reducer
 *
 */

import { fromJS } from 'immutable';
import { SET_PLAYLISTS } from './constants';

export const initialState = fromJS({
  playlists: [],
});

function listPageReducer(state = initialState, action) {
  switch (action.type) {
    case SET_PLAYLISTS:
      return state.set('playlists', action.data);
    default:
      return state;
  }
}

export default listPageReducer;
