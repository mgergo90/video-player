import { fromJS } from 'immutable';
import videoFilterReducer from '../reducer';

describe('videoFilterReducer', () => {
  it('returns the initial state', () => {
    expect(videoFilterReducer(undefined, {})).toEqual(fromJS({}));
  });
});
