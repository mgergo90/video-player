import { switchMap, map, catchError, tap } from 'rxjs/operators';
import { ofType } from 'redux-observable';
import axios from 'axios';
import { from, of } from 'rxjs';

import { loginUser } from 'containers/App/actions';
import { POST_REGISTRATION_FORM, REGISTRATION_ERROR } from './constants';

const loginPage = action$ =>
  action$.pipe(
    ofType(POST_REGISTRATION_FORM),
    map(action => ({
      ...action,
      userData: {
        data: {
          attributes: action.data,
        },
      },
    })),
    switchMap(action =>
      from(
        axios({
          method: 'POST',
          url: 'http://localhost:8040/api/user',
          data: action.userData,
        }),
      ).pipe(
        map(response => response.data.data),
        tap({
          error: error => {
            action.formActions.setStatus({ backendError: error.message });
            action.formActions.setSubmitting(false);
          },
          next: () => {
            action.formActions.setSubmitting(false);
          },
        }),
        map(() =>
          loginUser(
            {
              email: action.data.email,
              password: action.data.password,
            },
            action.formActions,
          ),
        ),
        catchError(error =>
          of({
            type: REGISTRATION_ERROR,
            error: error.message,
          }),
        ),
      ),
    ),
  );

export default loginPage;
