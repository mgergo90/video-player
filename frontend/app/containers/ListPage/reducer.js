/*
 *
 * ListPage reducer
 *
 */

import { fromJS } from 'immutable';
import { SET_PLAYLISTS, SET_PLAYLIST_ITEM } from './constants';

export const initialState = fromJS({
  playlists: [],
  playlistitem: null,
});

function listPageReducer(state = initialState, action) {
  switch (action.type) {
    case SET_PLAYLISTS:
      return state.set('playlists', action.data);
    case SET_PLAYLIST_ITEM:
      return state.set('playlistitem', action.item);
    default:
      return state;
  }
}

export default listPageReducer;
