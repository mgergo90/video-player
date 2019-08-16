import React, { useEffect, useState } from 'react';
import { compose } from 'redux';
import { connect } from 'react-redux';
import { withRouter } from 'react-router-dom';
import { createStructuredSelector } from 'reselect';
import YouTube from 'react-youtube';
import PropTypes from 'prop-types';

import VideoFilter from 'containers/VideoFilter';
import { selectVideos } from './selectors';
import { fetchVideos } from './actions';

const { Echo } = window;

const PlayListPage = props => {
  const [videoId, setVideoId] = useState(null);
  const {
    match: { params },
  } = props;
  useEffect(() => {
    props.fetchVideos(params.id);
    Echo.channel(`playlist.${params.id}`).listen('NewVideoEvent', e => {
      setVideoId(e.videoId);
    });
    return () => Echo.leaveChannel(`playlist.${params.id}`);
  }, []);

  return (
    <React.Fragment>
      <VideoFilter />
      {videoId && (
        <YouTube
          videoId={videoId} // defaults -> null
        />
      )}
    </React.Fragment>
  );
};

PlayListPage.propTypes = {
  match: PropTypes.instanceOf(Object).isRequired,
  fetchVideos: PropTypes.func.isRequired,
};

const mapStateToProps = createStructuredSelector({
  videos: selectVideos,
});

const mapDispatchToProps = dispatch => ({
  fetchVideos: compose(
    dispatch,
    fetchVideos,
  ),
});

export default withRouter(
  connect(
    mapStateToProps,
    mapDispatchToProps,
  )(PlayListPage),
);
