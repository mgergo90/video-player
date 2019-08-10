import { switchMap, map, catchError } from 'rxjs/operators';
import { ofType } from 'redux-observable';
import { from, of } from 'rxjs';
import axios from 'axios';

import { setPlaylists } from './actions';
import { FETCH_PLAYLISTS } from './constants';

const videoFilter = action$ =>
  action$.pipe(
    ofType(FETCH_PLAYLISTS),
    switchMap(() =>
      from(axios.get('/play-lists').then(response => response.data.data)).pipe(
        map(setPlaylists),
        catchError(() => of({ type: 'empty' })),
      ),
    ),
  );

export default videoFilter;
