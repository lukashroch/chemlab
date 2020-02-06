export function download(res) {
  let filename = res.headers['content-disposition']
    .split(';')
    .find(item => item.trim().startsWith('filename='));
  filename =
    typeof filename === 'undefined'
      ? `File_${res.headers.date}`
      : filename.replace('filename=', '').trim();
  const blob = new Blob([res.data], { type: 'application/octet-stream' });

  if (typeof window.navigator.msSaveBlob !== 'undefined') {
    window.navigator.msSaveBlob(blob, filename);
  } else {
    const url = window.URL.createObjectURL(new Blob([res.data]));
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    window.URL.revokeObjectURL(url);
  }
}

export function print(res) {
  const w = window.open('about:blank', 'windowname');
  w.document.open();
  w.document.write(res.data);
  w.document.close();
}

export default {
  download,
  print
};
