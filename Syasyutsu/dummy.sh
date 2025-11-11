#!/bin/bash
while true; do
  width=$(awk -v r=$RANDOM 'BEGIN{s=50+(r/32767*10); printf "%.2f", s}')
  height=$(awk -v r=$RANDOM 'BEGIN{s=25+(r/32767*20); printf "%.2f", s}')
  depth=$(awk -v r=$RANDOM 'BEGIN{s=15+(r/32767*20); printf "%.2f", s}')

  if (( $(echo "$width > $height" | bc -l) )) && \
     (( $(echo "$height >= $depth" | bc -l) )); then
    echo "横=$width 縦=$height 高さ=$depth"
    break
  fi
done
