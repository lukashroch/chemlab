export function today() {
  return new Date()
    .toLocaleDateString('cs', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
    })
    .replace(/\s/g, '');
}
