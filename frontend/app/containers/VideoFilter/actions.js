/*
 *
 * VideoFilter actions
 *
 */

import { FETCH_YOUTUBE_VIDEOS, SET_RESULT_LIST } from './constants';

export const fetchYoutubeVideos = term => ({
  type: FETCH_YOUTUBE_VIDEOS,
  term,
});

export const setResultList = response => ({
  type: SET_RESULT_LIST,
  response,
});
