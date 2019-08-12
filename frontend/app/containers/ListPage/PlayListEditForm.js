import React, { useEffect } from 'react';
import { withRouter } from 'react-router-dom';
import { connect } from 'react-redux';
import { createStructuredSelector } from 'reselect';
import { compose } from 'redux';

import PlayListForm from './PlayListForm';
import { selectItem } from './selectors';
import { fetchPlayListItem, setPlayListItem } from './actions';

const PlayListAddForm = props => {
  useEffect(
    () => {
      props.setPlayListItem(null);
      props.fetchPlayListItem(props.match.params.id);
    },
    [props.match.params.id],
  );

  if (!props.item) {
    return null;
  }
  return (
    <PlayListForm {...props} playList={props.item} title="Edit Playlist" />
  );
};

const mapStateToProps = createStructuredSelector({
  item: selectItem,
});

const mapDispatchToProps = dispatch => ({
  fetchPlayListItem: compose(
    dispatch,
    fetchPlayListItem,
  ),
  setPlayListItem: compose(
    dispatch,
    setPlayListItem,
  ),
});

export default withRouter(
  connect(
    mapStateToProps,
    mapDispatchToProps,
  )(PlayListAddForm),
);
