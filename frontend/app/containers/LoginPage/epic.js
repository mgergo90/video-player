import { switchMap, map, catchError, tap } from 'rxjs/operators';
import { ofType } from 'redux-observable';
import axios from 'axios';

import { from, of } from 'rxjs';
import { LOGIN_USER, LOGIN_USER_ERROR } from './constants';

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
        tap({
          error: error => {
            action.formActions.setStatus({ backendError: error.message });
            action.formActions.setSubmitting(false);
          },
          next: () => action.formActions.setSubmitting(false),
        }),
        catchError(error =>
          of({
            type: LOGIN_USER_ERROR,
            error: error.message,
          }),
        ),
      ),
    ),
  );

export default loginPage;
