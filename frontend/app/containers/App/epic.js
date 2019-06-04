import { switchMap, map, catchError, tap, mapTo } from 'rxjs/operators';
import { ofType, combineEpics } from 'redux-observable';
import axios from 'axios';
import { from, of } from 'rxjs';
import { push } from 'connected-react-router';

import { setUserData } from 'containers/App/actions';
import { LOGIN_USER, LOGIN_USER_ERROR, SET_USER_DATA } from './constants';

const loginPage = action$ =>
  action$.pipe(
    ofType(LOGIN_USER),
    map(action => ({
      ...action,
      credentials: {
        data: {
          attributes: action.credentials,
        },
      },
    })),
    switchMap(action =>
      from(
        axios({
          method: 'POST',
          url: 'http://localhost:8040/api/auth/login',
          data: action.credentials,
        }),
      ).pipe(
        map(response => response.data.data),
        tap({
          error: error => {
            action.formActions.setStatus({ backendError: error.message });
            action.formActions.setSubmitting(false);
          },
          next: user => {
            action.formActions.setSubmitting(false);
            localStorage.setItem('user', JSON.stringify(user));
          },
        }),
        map(user => setUserData(user)),
        catchError(error =>
          of({
            type: LOGIN_USER_ERROR,
            error: error.message,
          }),
        ),
      ),
    ),
  );

const redirectAfterLogin = $action =>
  $action.pipe(
    ofType(SET_USER_DATA),
    mapTo(push('/')),
  );

export default combineEpics(loginPage, redirectAfterLogin);
