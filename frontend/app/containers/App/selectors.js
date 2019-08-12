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

const makeSelectCurrentUserId = createSelector(
  createSelector(selectGlobal, globalState => globalState.get('user')),
  user => user.id,
);

export { makeSelectCurrentUser, selectInitialize, makeSelectCurrentUserId };
