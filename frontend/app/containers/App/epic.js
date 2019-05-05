import { mergeMap, map } from 'rxjs/operators';
import { ofType } from 'redux-observable';
import { ajax } from 'rxjs/ajax';
import { FETCH_USER } from './constants';

const appEpic = action$ =>
  action$.pipe(
    ofType(FETCH_USER),
    mergeMap(action =>
      ajax
        .getJSON(`https://api.github.com/users/${action.user}`)
        .pipe(map(response => console.log(response))),
    ),
  );

export default appEpic;
