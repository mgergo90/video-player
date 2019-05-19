/*
 *
 * LoginPage actions
 *
 */

import { LOGIN_USER } from './constants';

export const loginUser = (credentials, formActions) => ({
  type: LOGIN_USER,
  credentials,
  formActions,
});
