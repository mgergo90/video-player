/**
 * The global state selectors
 */

import { createSelector } from 'reselect';

const selectGlobal = state => state.get('global');

const makeSelectCurrentUser = () =>
  createSelector(selectGlobal, globalState => globalState.get('user'));

const selectInitialize = createSelector(selectGlobal, globalState =>
  globalState.get('initialize'),
);

export { makeSelectCurrentUser, selectInitialize };
