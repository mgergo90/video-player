import { createSelector } from 'reselect';
import { initialState } from './reducer';

/**
 * Direct selector to the videoFilter state domain
 */

const selectVideoFilterDomain = state => state.get('videoFilter', initialState);

/**
 * Other specific selectors
 */

/**
 * Default selector used by VideoFilter
 */

const makeSelectVideoFilter = () =>
  createSelector(selectVideoFilterDomain, substate => substate.toJS());

const makeSelectOptions = () =>
  createSelector(selectVideoFilterDomain, substate => {
    console.log(substate.toJS());
    return substate.toJS().options.map(video => ({
      value: video.id,
      label: video.attributes.title,
    }));
  });

const makeSelectLoading = () =>
  createSelector(selectVideoFilterDomain, substate => substate.toJS().loading);

const makeSelectTerm = () =>
  createSelector(selectVideoFilterDomain, substate => substate.toJS().term);

export default makeSelectVideoFilter;
export {
  selectVideoFilterDomain,
  makeSelectOptions,
  makeSelectLoading,
  makeSelectTerm,
};
