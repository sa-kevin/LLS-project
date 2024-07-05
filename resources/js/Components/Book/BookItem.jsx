import { useState } from 'react';
import BookCard from './BookCard';
import { Inertia } from '@inertiajs/inertia';

export default function BookItem({ book }) {
  const [isModalOpen, setIsModalOpen] = useState(false);

  const handleRentOrWait = () => {
    console.log('Rent or wait for:', book.title);
  };
  const handleAddToWishlist = () => {
    console.log('add to wishlist:', book.title);
  };

  return (
    <>
      <div className="bg-white shadow-sm border border-gray-200 rounded-lg p-4 flex justify-between items-center">
        <div>
          <div className="flex items-center mb-2">
            <h3 className="font-bold text-xl mr-4">{book.title}</h3>
            <p className="text-gray-700 text-sm">{book.author}</p>
          </div>
          <p className="text-gray-500 text-sm">ISBN: {book.isbn} </p>
        </div>
        <button
          onClick={() => setIsModalOpen(true)}
          className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4"
          //href={route('books.show', book.id)}
        >
          View Details
        </button>
      </div>
      {isModalOpen && (
        <BookCard
          book={book}
          onClose={() => setIsModalOpen(false)}
          onRentOrWait={handleRentOrWait}
          onAddToWishlist={handleAddToWishlist}
        />
      )}
    </>
  );
}
