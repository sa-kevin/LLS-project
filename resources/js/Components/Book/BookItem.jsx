import { useState } from 'react';
import BookCard from './BookCard';
import { router } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Inertia } from '@inertiajs/inertia';

export default function BookItem({ book, loans }) {
  const [isModalOpen, setIsModalOpen] = useState(false);

  const handleLoans = (dueDate) => {
    router.post(
      route('loans.store'),
      { book_id: book.id, due_date: dueDate },
      { preserveState: true, preserveScroll: true }
    );
    console.log('Rent:', book.title);
    setIsModalOpen(false);
  };

  const handleWaitList = () => {
    router.post(
      route('waitinglists.store'),
      { book_id: book.id },
      { preserveState: true, preserveScroll: true }
    );
    console.log('add user to waitng list for:', book.title);
    setIsModalOpen(false);
  };
  const handleAddToWishlist = () => {
    router.post(
      route('wishlists.store'),
      {
        book_id: book.id,
      },
      {
        preserveState: true,
        preserveScroll: true,
      }
    );
    setIsModalOpen(false);
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
        >
          View Details
        </button>
      </div>
      {isModalOpen && (
        <BookCard
          book={book}
          loans={book.loans}
          onClose={() => setIsModalOpen(false)}
          onLoan={handleLoans}
          onWait={handleWaitList}
          onAddToWishlist={handleAddToWishlist}
          isAvailable={book.is_available}
          waitingListCount={book.waiting_list_count}
        />
      )}
    </>
  );
}
