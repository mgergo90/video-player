/*
 *
 * ListPage reducer
 *
 */

import { fromJS } from 'immutable';
import { SET_PLAYLISTS, SET_PLAYLIST_ITEM, SET_VIDEOS_LIST } from './constants';

export const initialState = fromJS({
  playlists: [],
  playlistitem: null,
  videos: [],
});

function listPageReducer(state = initialState, action) {
  switch (action.type) {
    case SET_PLAYLISTS:
      return state.set('playlists', action.data);
    case SET_PLAYLIST_ITEM:
      return state.set('playlistitem', action.item);
    case SET_VIDEOS_LIST:
      return state.set('video', action.videos);
    default:
      return state;
  }
}

export default listPageReducer;
