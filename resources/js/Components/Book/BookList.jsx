import BookItem from './BookItem';

export default function BookList({ books, translations }) {
  if (!books || books.length === 0) {
    return <p>{translations.no_book}</p>;
  }
  return (
    <div className="space-y-4">
      {books.map((book) => (
        <BookItem key={book.id} book={book} translations={translations} />
      ))}
    </div>
  );
}
