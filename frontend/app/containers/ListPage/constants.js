/*
 *
 * ListPage constants
 *
 */

export const FETCH_PLAYLISTS = 'app/ListPage/FETCH_PLAYLISTS';
export const SET_PLAYLISTS = 'app/ListPage/SET_PLAYLISTS';
export const SAVE_PLAYLIST = 'app/ListPage/SAVE_PLAYLIST';
export const FETCH_PLAYLIST_ITEM = 'app/ListPage/FETCH_PLAYLIST_ITEM';
export const SET_PLAYLIST_ITEM = 'app/ListPage/SET_PLAYLIST_ITEM';

export const playListSkeleton = {
  id: null,
  type: 'play-list',
  attributes: {
    name: '',
    user_id: 0,
  },
};
