/*
 *
 * RegistrationPage actions
 *
 */
import { POST_REGISTRATION_FORM } from './constants';

export const postRegistrationForm = (data, formActions) => ({
  type: POST_REGISTRATION_FORM,
  data,
  formActions,
});
