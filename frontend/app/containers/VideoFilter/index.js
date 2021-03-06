import React, { useState } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { FormattedMessage } from 'react-intl';
import { createStructuredSelector } from 'reselect';
import { compose } from 'redux';
import Select from 'react-select';
import { withStyles } from '@material-ui/core/styles';
import AppBar from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';

import injectEpic from 'utils/injectEpic';
import injectReducer from 'utils/injectReducer';
import {
  makeSelectOptions,
  makeSelectLoading,
  makeSelectTerm,
} from './selectors';
import reducer from './reducer';
import { fetchYoutubeVideos, saveVideo } from './actions';
import epic from './epic';
import messages from './messages';

const styles = {
  root: {
    flexGrow: 1,
    flex: 1,
  },
  filter: {
    minWidth: '300px',
    width: '50%',
    margin: '0 auto',
  },
};

const VideoFilter = ({
  onInputChange,
  options,
  classes,
  loading,
  term,
  postVideo,
}) => (
  <div className={classes.root}>
    <AppBar position="static" color="default">
      <Toolbar>
        <Select
          isClearable
          inputValue={term}
          onInputChange={onInputChange}
          onChange={postVideo}
          isLoading={loading}
          placeholder="Search..."
          options={options}
          className={classes.filter}
        />
      </Toolbar>
    </AppBar>
  </div>
);

VideoFilter.propTypes = {
  onInputChange: PropTypes.func.isRequired,
  postVideo: PropTypes.func.isRequired,
  options: PropTypes.instanceOf(Array).isRequired,
  classes: PropTypes.instanceOf(Object).isRequired,
  loading: PropTypes.bool.isRequired,
  term: PropTypes.string.isRequired,
};

const mapStateToProps = createStructuredSelector({
  options: makeSelectOptions(),
  loading: makeSelectLoading(),
  term: makeSelectTerm(),
});

const mapDispatchToProps = dispatch => ({
  onInputChange: compose(
    dispatch,
    fetchYoutubeVideos,
  ),
  postVideo: compose(
    dispatch,
    saveVideo,
  ),
});

const withConnect = connect(
  mapStateToProps,
  mapDispatchToProps,
);

const withReducer = injectReducer({ key: 'videoFilter', reducer });
const withEpic = injectEpic(epic, 'videoFilter');

export default compose(
  withReducer,
  withEpic,
  withConnect,
)(withStyles(styles)(VideoFilter));
