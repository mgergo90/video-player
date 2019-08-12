import React from 'react';

import PlayListForm from './PlayListForm';
import { playListSkeleton } from './constants';

const PlayListAddForm = props => (
  <PlayListForm
    {...props}
    playList={playListSkeleton}
    title="Add New Playlist"
  />
);

export default PlayListAddForm;
