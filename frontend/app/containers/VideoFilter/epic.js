import {
  switchMap,
  map,
  debounceTime,
  distinctUntilChanged,
} from 'rxjs/operators';
import { ofType } from 'redux-observable';
import { from, iif, of } from 'rxjs';
import search from 'youtube-search';
import { setResultList } from './actions';
import { FETCH_YOUTUBE_VIDEOS } from './constants';

const opts = { key: '' };

const videoFilter = action$ =>
  action$.pipe(
    ofType(FETCH_YOUTUBE_VIDEOS),
    debounceTime(250),
    distinctUntilChanged(),
    switchMap(action =>
      iif(
        () => action.term.length > 2,
        from(search(action.term, opts)),
        of({ results: [] }),
      ).pipe(map(result => setResultList(result.results))),
    ),
  );

export default videoFilter;
