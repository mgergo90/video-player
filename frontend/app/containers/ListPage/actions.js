/*
 *
 * ListPage actions
 *
 */

import {
  FETCH_PLAYLISTS,
  SET_PLAYLISTS,
  SAVE_PLAYLIST,
  FETCH_PLAYLIST_ITEM,
  SET_PLAYLIST_ITEM,
} from './constants';

export const fetchPlayLists = () => ({
  type: FETCH_PLAYLISTS,
});

export const setPlaylists = data => ({
  type: SET_PLAYLISTS,
  data,
});

export const savePlayList = (playlistData, formActions) => ({
  type: SAVE_PLAYLIST,
  playlistData,
  formActions,
});

export const fetchPlayListItem = id => ({
  type: FETCH_PLAYLIST_ITEM,
  id,
});

export const setPlayListItem = item => ({
  type: SET_PLAYLIST_ITEM,
  item,
});
