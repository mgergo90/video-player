import {
  switchMap,
  map,
  catchError,
  tap,
  mapTo,
  withLatestFrom,
} from 'rxjs/operators';
import { ofType, combineEpics } from 'redux-observable';
import { from, of, concat } from 'rxjs';
import { push } from 'connected-react-router';
import axios from 'axios';
import { setWith, clone } from 'lodash';

import { makeSelectCurrentUserId } from 'containers/App/selectors';
import { setPlaylists, setPlayListItem, setVideoList } from './actions';
import {
  FETCH_PLAYLISTS,
  SAVE_PLAYLIST,
  FETCH_PLAYLIST_ITEM,
  FETCH_VIDEOS,
} from './constants';

const getUrl = (baseUrl, id) => {
  if (!id) {
    return baseUrl;
  }
  return `${baseUrl}/${id}`;
};

const fetchPlayLists = action$ =>
  action$.pipe(
    ofType(FETCH_PLAYLISTS),
    switchMap(() =>
      from(axios.get('/play-lists').then(response => response.data.data)).pipe(
        map(setPlaylists),
        catchError(() => of({ type: 'empty' })),
      ),
    ),
  );

const fetchPlayListItem = action$ =>
  action$.pipe(
    ofType(FETCH_PLAYLIST_ITEM),
    switchMap(action =>
      from(axios.get(getUrl('/play-lists', action.id))).pipe(
        map(response => response.data.data),
        map(setPlayListItem),
        catchError(() => of({ type: 'empty' })),
      ),
    ),
  );

const savePlayList = (action$, state$) =>
  action$.pipe(
    ofType(SAVE_PLAYLIST),
    withLatestFrom(state$),
    map(([action, state]) => [
      {
        ...setWith(
          clone(action),
          'playlistData.attributes.user_id',
          makeSelectCurrentUserId(state),
          clone,
        ),
      },
      state,
    ]),
    switchMap(([action]) =>
      concat(
        from(
          axios({
            method: action.playlistData.id ? 'PUT' : 'POST',
            url: getUrl('/play-lists', action.playlistData.id),
            data: { data: action.playlistData },
          }),
        ).pipe(
          map(response => response.data.data),
          tap({
            error: () => action.formActions.setSubmitting(false),
            next: () => {
              action.formActions.setSubmitting(false);
            },
          }),
          mapTo(push('/play-lists')),
          catchError(error => {
            action.formActions.setStatus({ backendError: error.message });
            return of({ type: 'empty' });
          }),
        ),
        of(setPlayListItem()),
      ),
    ),
  );

const fetchVideos = action$ =>
  action$.pipe(
    ofType(FETCH_VIDEOS),
    switchMap(action =>
      from(axios.get(getUrl('/videos', null))).pipe(
        map(response => response.data.data),
        map(setVideoList),
        catchError(() => of({ type: 'empty' })),
      ),
    ),
  );

export default combineEpics(
  fetchPlayLists,
  savePlayList,
  fetchPlayListItem,
  fetchVideos,
);
