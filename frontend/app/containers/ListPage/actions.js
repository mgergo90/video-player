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
  FETCH_VIDEOS,
  SET_VIDEOS_LIST,
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

export const fetchVideos = id => ({
  type: FETCH_VIDEOS,
  id,
});

export const setVideoList = videos => ({
  type: SET_VIDEOS_LIST,
  videos,
});
