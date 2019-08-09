/*
 *
 * ListPage actions
 *
 */

import { FETCH_PLAYLISTS, SET_PLAYLISTS } from './constants';

export const fetchPlayLists = () => ({
  type: FETCH_PLAYLISTS,
});

export const setPlaylists = data => ({
  type: SET_PLAYLISTS,
  data,
});
