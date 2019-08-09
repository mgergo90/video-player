import {
  switchMap,
  map,
  catchError,
  tap,
  mapTo,
  ignoreElements,
} from 'rxjs/operators';
import { ofType, combineEpics } from 'redux-observable';
import axios from 'axios';
import { from, of } from 'rxjs';
import { push } from 'connected-react-router';

import { setUserData } from 'containers/App/actions';
import {
  LOGIN_USER,
  SET_USER_DATA,
  LOGOUT_USER,
  TRY_AUTHENTICATE,
} from './constants';

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
          url: '/auth/login',
          data: action.credentials,
        }),
      ).pipe(
        map(response => response.data.data),
        tap({
          error: () => action.formActions.setSubmitting(false),
          next: () => {
            action.formActions.setSubmitting(false);
          },
        }),
        map(setUserData),
        catchError(error => {
          action.formActions.setStatus({ backendError: error.message });
          return of({ type: 'empty' });
        }),
      ),
    ),
  );

const logoutUser = action$ =>
  action$.pipe(
    ofType(LOGOUT_USER),
    switchMap(() =>
      from(
        axios({
          method: 'GET',
          url: '/auth/logout',
        }),
      ).pipe(
        map(() => setUserData(null)),
        catchError(() => of(setUserData(null))),
      ),
    ),
  );

const redirectAfterUserChange = $action =>
  $action.pipe(
    ofType(SET_USER_DATA),
    tap(action => {
      axios.defaults.headers.common['CSRF-Token'] = null;
      if (action.user) {
        axios.defaults.headers.common['CSRF-Token'] =
          action.user.attributes.csrf_token;
      }
    }),
    ignoreElements(),
  );

const tryAuthenticate = $action =>
  $action.pipe(
    ofType(TRY_AUTHENTICATE),
    switchMap(() =>
      from(axios.get('/auth/me')).pipe(
        map(response => response.data.data),
        map(setUserData),
        catchError(() => of({ type: 'empty' })),
      ),
    ),
  );

export default combineEpics(
  loginPage,
  redirectAfterUserChange,
  logoutUser,
  tryAuthenticate,
);
