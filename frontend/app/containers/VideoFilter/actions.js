/*
 *
 * VideoFilter actions
 *
 */

import { FETCH_YOUTUBE_VIDEOS, SET_RESULT_LIST, SAVE_VIDEO } from './constants';

export const fetchYoutubeVideos = term => ({
  type: FETCH_YOUTUBE_VIDEOS,
  term,
});

export const setResultList = options => ({
  type: SET_RESULT_LIST,
  options,
});

export const saveVideo = video => ({
  type: SAVE_VIDEO,
  video,
});
