import { createSelector } from 'reselect';
import { initialState } from './reducer';

/**
 * Direct selector to the listPage state domain
 */

const selectListPageDomain = state => state.get('listPage', initialState);

/**
 * Other specific selectors
 */

/**
 * Default selector used by ListPage
 */

const makeSelectListPage = () =>
  createSelector(selectListPageDomain, substate => substate.toJS());

const selectLists = createSelector(
  selectListPageDomain,
  substate => substate.toJS().playlists,
);

const selectItem = createSelector(
  selectListPageDomain,
  substate => substate.toJS().playlistitem,
);

const selectVideos = createSelector(
  selectListPageDomain,
  substate => substate.toJS().videos,
);

export default makeSelectListPage;
export { selectListPageDomain, selectLists, selectItem, selectVideos };
