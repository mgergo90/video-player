/*
 * LoginPage Messages
 *
 * This contains all the text for the LoginPage container.
 */

import { defineMessages } from 'react-intl';

export const scope = 'app.containers.LoginPage';

export default defineMessages({
  header: {
    id: `${scope}.header`,
    defaultMessage: 'Login',
  },
  email: {
    id: `${scope}.email`,
    defaultMessage: 'E-mail',
  },
  required: {
    id: `${scope}.required`,
    defaultMessage: 'Required field',
  },
  emailInvalid: {
    id: `${scope}.emailInvalid`,
    defaultMessage: 'Invalid e-mail',
  },
  password: {
    id: `${scope}.password`,
    defaultMessage: 'Password',
  },
  loginButton: {
    id: `${scope}.loginButton`,
    defaultMessage: 'Login',
  },
  newAccountButton: {
    id: `${scope}.newAccountButton`,
    defaultMessage: 'Create New Account',
  },
});
