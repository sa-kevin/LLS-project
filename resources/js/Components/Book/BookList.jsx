import BookItem from './BookItem';

export default function BookList({ books }) {
  console.log('BookList received books:', books);

  if (!books || books.length === 0) {
    return <p>No Books available.</p>;
  }
  return (
    <div className="space-y-4">
      {books.map((book) => (
        <BookItem key={book.id} book={book} />
      ))}
    </div>
  );
}
