import {
  switchMap,
  map,
  debounceTime,
  distinctUntilChanged,
  ignoreElements,
  catchError,
} from 'rxjs/operators';
import { ofType, combineEpics } from 'redux-observable';
import { from, iif, of } from 'rxjs';
import axios from 'axios';
import qs from 'qs';

import { setResultList } from './actions';
import { FETCH_YOUTUBE_VIDEOS, SAVE_VIDEO } from './constants';

const videoFilter = action$ =>
  action$.pipe(
    ofType(FETCH_YOUTUBE_VIDEOS),
    debounceTime(250),
    distinctUntilChanged(),
    switchMap(action =>
      iif(
        () => action.term.length > 2,
        from(
          axios
            .get('/youtube/search', {
              params: {
                filters: {
                  term: action.term,
                },
              },
              paramsSerializer: param => qs.stringify(param, { encode: false }),
            })
            .then(response => response.data.data)
            .catch(() => []),
        ),
        of([]),
      ).pipe(map(setResultList)),
    ),
  );

const saveVideo = action$ =>
  action$.pipe(
    ofType(SAVE_VIDEO),
    switchMap(action =>
      from(
        axios.post('videos', {
          data: {
            attributes: {
              video_id: action.video.value,
              play_list_id: 1,
            },
          },
        }),
      ),
    ),
    ignoreElements(),
    catchError(() => of({ type: 'empty' })),
  );

export default combineEpics(videoFilter, saveVideo);
