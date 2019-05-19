import {
  switchMap,
  map,
  debounceTime,
  distinctUntilChanged,
} from 'rxjs/operators';
import { ofType } from 'redux-observable';
import { from, iif, of } from 'rxjs';
import axios from 'axios';
import qs from 'qs';

import { setResultList } from './actions';
import { FETCH_YOUTUBE_VIDEOS } from './constants';

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
            .get('http://localhost:8040/api/youtube/search', {
              params: {
                filters: {
                  term: action.term,
                },
              },
              paramsSerializer: param => qs.stringify(param, { encode: false }),
            })
            .then(response => response.data.data),
        ),
        of([]),
      ).pipe(map(setResultList)),
    ),
  );

export default videoFilter;
