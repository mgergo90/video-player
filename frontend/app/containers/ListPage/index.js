/**
 *
 * ListPage
 *
 */

import React, { useEffect } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { FormattedMessage } from 'react-intl';
import { createStructuredSelector } from 'reselect';
import { compose } from 'redux';

import injectEpic from 'utils/injectEpic';
import injectReducer from 'utils/injectReducer';
import makeSelectListPage from './selectors';
import reducer from './reducer';
import epic from './epic';
import messages from './messages';
import { fetchPlayLists } from './actions';

const ListPage = props => {
  useEffect(() => {
    props.fetchPlayLists();
  }, []);

  const name = 'ListPage';
  return (
    <div>
      <FormattedMessage {...messages.header} />
      <h1>{name}</h1>
    </div>
  );
};

ListPage.propTypes = {
  fetchPlayLists: PropTypes.func.isRequired,
};

const mapStateToProps = createStructuredSelector({
  listPage: makeSelectListPage(),
});

const mapDispatchToProps = dispatch => ({
  fetchPlayLists: compose(
    dispatch,
    fetchPlayLists,
  ),
});

const withConnect = connect(
  mapStateToProps,
  mapDispatchToProps,
);

const withReducer = injectReducer({ key: 'listPage', reducer });
const withEpic = injectEpic(epic);

export default compose(
  withReducer,
  withEpic,
  withConnect,
)(ListPage);
